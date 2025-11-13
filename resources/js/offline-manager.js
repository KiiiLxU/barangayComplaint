// Offline Manager for Barangay Complaint System
class OfflineManager {
    constructor() {
        this.dbName = 'barangayComplaints';
        this.dbVersion = 1;
        this.db = null;
        this.isOnline = navigator.onLine;
        this.pendingComplaints = [];
        this.init();
    }

    async init() {
        await this.initDB();
        this.setupEventListeners();
        this.loadPendingComplaints();
        this.registerServiceWorker();
    }

    async initDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onerror = () => reject(request.error);
            request.onsuccess = () => {
                this.db = request.result;
                resolve();
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                // Create object stores
                if (!db.objectStoreNames.contains('pendingComplaints')) {
                    const complaintsStore = db.createObjectStore('pendingComplaints', { keyPath: 'id', autoIncrement: true });
                    complaintsStore.createIndex('timestamp', 'timestamp', { unique: false });
                }

                if (!db.objectStoreNames.contains('cachedData')) {
                    db.createObjectStore('cachedData', { keyPath: 'key' });
                }
            };
        });
    }

    setupEventListeners() {
        window.addEventListener('online', () => {
            this.isOnline = true;
            this.syncPendingComplaints();
        });

        window.addEventListener('offline', () => {
            this.isOnline = false;
        });
    }

    async registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            try {
                const registration = await navigator.serviceWorker.register('/sw.js');
                console.log('Service Worker registered:', registration);
            } catch (error) {
                console.error('Service Worker registration failed:', error);
            }
        }
    }

    async saveComplaintOffline(complaintData) {
        const complaint = {
            ...complaintData,
            timestamp: Date.now(),
            synced: false
        };

        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pendingComplaints'], 'readwrite');
            const store = transaction.objectStore('pendingComplaints');
            const request = store.add(complaint);

            request.onsuccess = () => {
                this.pendingComplaints.push(complaint);
                resolve(complaint);
            };
            request.onerror = () => reject(request.error);
        });
    }

    async loadPendingComplaints() {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pendingComplaints'], 'readonly');
            const store = transaction.objectStore('pendingComplaints');
            const request = store.getAll();

            request.onsuccess = () => {
                this.pendingComplaints = request.result;
                resolve(request.result);
            };
            request.onerror = () => reject(request.error);
        });
    }

    async syncPendingComplaints() {
        if (!this.isOnline || this.pendingComplaints.length === 0) return;

        for (const complaint of this.pendingComplaints) {
            try {
                const formData = new FormData();

                // Convert complaint data to FormData
                Object.keys(complaint).forEach(key => {
                    if (key !== 'id' && key !== 'timestamp' && key !== 'synced') {
                        if (key === 'photo' && complaint[key]) {
                            // Handle file data if present
                            formData.append(key, complaint[key]);
                        } else {
                            formData.append(key, complaint[key]);
                        }
                    }
                });

                const response = await fetch('/complaints', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    // Remove from pending complaints
                    await this.removePendingComplaint(complaint.id);
                    complaint.synced = true;
                }
            } catch (error) {
                console.error('Failed to sync complaint:', error);
            }
        }
    }

    async removePendingComplaint(id) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['pendingComplaints'], 'readwrite');
            const store = transaction.objectStore('pendingComplaints');
            const request = store.delete(id);

            request.onsuccess = () => {
                this.pendingComplaints = this.pendingComplaints.filter(c => c.id !== id);
                resolve();
            };
            request.onerror = () => reject(request.error);
        });
    }

    async cacheData(key, data) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['cachedData'], 'readwrite');
            const store = transaction.objectStore('cachedData');
            const request = store.put({ key, data, timestamp: Date.now() });

            request.onsuccess = () => resolve();
            request.onerror = () => reject(request.error);
        });
    }

    async getCachedData(key) {
        return new Promise((resolve, reject) => {
            const transaction = this.db.transaction(['cachedData'], 'readonly');
            const store = transaction.objectStore('cachedData');
            const request = store.get(key);

            request.onsuccess = () => resolve(request.result?.data);
            request.onerror = () => reject(request.error);
        });
    }

    getPendingComplaintsCount() {
        return this.pendingComplaints.length;
    }

    isOffline() {
        return !this.isOnline;
    }
}

// Initialize offline manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.offlineManager = new OfflineManager();
});

// Export for module use
export default OfflineManager;
