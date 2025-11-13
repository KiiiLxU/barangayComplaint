import React, { useState, useEffect } from 'react';
import api from '../../services/api';

const OfficialsList = () => {
    const [officials, setOfficials] = useState([]);
    const [loading, setLoading] = useState(true);
    const [showForm, setShowForm] = useState(false);
    const [editingOfficial, setEditingOfficial] = useState(null);
    const [formData, setFormData] = useState({
        name: '',
        position: '',
        purok_assigned: '',
        contact_no: '',
        photo: null
    });
    const [formLoading, setFormLoading] = useState(false);

    useEffect(() => {
        fetchOfficials();
    }, []);

    const fetchOfficials = async () => {
        try {
            const response = await api.get('/officials');
            if (response.data.success) {
                setOfficials(response.data.data.data || []);
            }
        } catch (error) {
            console.error('Error fetching officials:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleInputChange = (e) => {
        const { name, value, files } = e.target;
        if (name === 'photo' && files) {
            setFormData({ ...formData, [name]: files[0] });
        } else {
            setFormData({ ...formData, [name]: value });
        }
    };

    const resetForm = () => {
        setFormData({
            name: '',
            position: '',
            purok_assigned: '',
            contact_no: '',
            photo: null
        });
        setEditingOfficial(null);
        setShowForm(false);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setFormLoading(true);

        try {
            const submitData = new FormData();
            Object.keys(formData).forEach(key => {
                if (formData[key]) {
                    submitData.append(key, formData[key]);
                }
            });

            if (editingOfficial) {
                await api.post(`/officials/${editingOfficial.id}`, submitData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
            } else {
                await api.post('/officials', submitData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
            }

            fetchOfficials();
            resetForm();
        } catch (error) {
            console.error('Error saving official:', error);
        } finally {
            setFormLoading(false);
        }
    };

    const handleEdit = (official) => {
        setEditingOfficial(official);
        setFormData({
            name: official.name,
            position: official.position,
            purok_assigned: official.purok_assigned || '',
            contact_no: official.contact_no || '',
            photo: null
        });
        setShowForm(true);
    };

    const handleDelete = async (id) => {
        if (window.confirm('Are you sure you want to delete this official?')) {
            try {
                await api.delete(`/officials/${id}`);
                fetchOfficials();
            } catch (error) {
                console.error('Error deleting official:', error);
            }
        }
    };

    if (loading) {
        return (
            <div className="flex justify-center items-center h-64">
                <div className="animate-spin rounded-full h-32 w-32 border-b-2 border-indigo-500"></div>
            </div>
        );
    }

    return (
        <div className="px-4 py-6 sm:px-0">
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-3xl font-bold text-gray-900">Barangay Officials</h1>
                <button
                    onClick={() => setShowForm(true)}
                    className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                >
                    Add Official
                </button>
            </div>

            {/* Form Modal */}
            {showForm && (
                <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div className="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div className="mt-3">
                            <h3 className="text-lg font-medium text-gray-900 mb-4">
                                {editingOfficial ? 'Edit Official' : 'Add New Official'}
                            </h3>
                            <form onSubmit={handleSubmit} className="space-y-4">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        value={formData.name}
                                        onChange={handleInputChange}
                                        required
                                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Position</label>
                                    <input
                                        type="text"
                                        name="position"
                                        value={formData.position}
                                        onChange={handleInputChange}
                                        required
                                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Purok Assigned</label>
                                    <input
                                        type="text"
                                        name="purok_assigned"
                                        value={formData.purok_assigned}
                                        onChange={handleInputChange}
                                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Contact Number</label>
                                    <input
                                        type="text"
                                        name="contact_no"
                                        value={formData.contact_no}
                                        onChange={handleInputChange}
                                        className="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    />
                                </div>
                                <div>
                                    <label className="block text-sm font-medium text-gray-700">Photo</label>
                                    <input
                                        type="file"
                                        name="photo"
                                        accept="image/*"
                                        onChange={handleInputChange}
                                        className="mt-1 block w-full"
                                    />
                                </div>
                                <div className="flex justify-end space-x-3">
                                    <button
                                        type="button"
                                        onClick={resetForm}
                                        className="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={formLoading}
                                        className="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 disabled:opacity-50"
                                    >
                                        {formLoading ? 'Saving...' : (editingOfficial ? 'Update' : 'Create')}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            )}

            {/* Officials List */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {officials.map((official) => (
                    <div key={official.id} className="bg-white overflow-hidden shadow rounded-lg">
                        <div className="p-6">
                            {official.photo && (
                                <img
                                    src={`http://127.0.0.1:8000/storage/${official.photo}`}
                                    alt={official.name}
                                    className="w-24 h-24 rounded-full mx-auto mb-4 object-cover"
                                />
                            )}
                            <div className="text-center">
                                <h3 className="text-lg font-medium text-gray-900">{official.name}</h3>
                                <p className="text-sm text-gray-600">{official.position}</p>
                                {official.purok_assigned && (
                                    <p className="text-sm text-gray-500">Purok: {official.purok_assigned}</p>
                                )}
                                {official.contact_no && (
                                    <p className="text-sm text-gray-500">Contact: {official.contact_no}</p>
                                )}
                            </div>
                            <div className="mt-4 flex justify-center space-x-2">
                                <button
                                    onClick={() => handleEdit(official)}
                                    className="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                >
                                    Edit
                                </button>
                                <button
                                    onClick={() => handleDelete(official.id)}
                                    className="inline-flex items-center px-3 py-1 border border-red-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            {officials.length === 0 && (
                <div className="text-center py-12">
                    <p className="text-gray-500">No officials found.</p>
                    <button
                        onClick={() => setShowForm(true)}
                        className="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-indigo-100 hover:bg-indigo-200"
                    >
                        Add your first official
                    </button>
                </div>
            )}
        </div>
    );
};

export default OfficialsList;
