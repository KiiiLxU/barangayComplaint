import React, { useState, useEffect } from 'react';
import { useAuth } from '../../contexts/AuthContext';
import api from '../../services/api';

const Dashboard = () => {
    const { user, isAdmin } = useAuth();
    const [stats, setStats] = useState({
        totalComplaints: 0,
        pendingComplaints: 0,
        resolvedComplaints: 0,
        investigatingComplaints: 0
    });
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchStats();
    }, []);

    const fetchStats = async () => {
        try {
            if (isAdmin) {
                const response = await api.get('/complaints');
                const complaints = response.data.data.data || response.data.data;
                const stats = {
                    totalComplaints: complaints.length,
                    pendingComplaints: complaints.filter(c => c.status === 'pending').length,
                    resolvedComplaints: complaints.filter(c => c.status === 'resolved').length,
                    investigatingComplaints: complaints.filter(c => c.status === 'investigating').length
                };
                setStats(stats);
            } else {
                const response = await api.get('/complaints');
                const complaints = response.data.data.data || response.data.data;
                const stats = {
                    totalComplaints: complaints.length,
                    pendingComplaints: complaints.filter(c => c.status === 'pending').length,
                    resolvedComplaints: complaints.filter(c => c.status === 'resolved').length,
                    investigatingComplaints: complaints.filter(c => c.status === 'investigating').length
                };
                setStats(stats);
            }
        } catch (error) {
            console.error('Error fetching stats:', error);
        } finally {
            setLoading(false);
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
            <div className="mb-8">
                <h1 className="text-3xl font-bold text-gray-900">
                    Welcome back, {user?.name}!
                </h1>
                <p className="mt-2 text-gray-600">
                    {isAdmin ? 'Admin Dashboard' : 'User Dashboard'} - Barangay Complaint System
                </p>
            </div>

            {/* Stats Cards */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0">
                                <div className="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <span className="text-white text-sm font-bold">T</span>
                                </div>
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">
                                        Total Complaints
                                    </dt>
                                    <dd className="text-lg font-medium text-gray-900">
                                        {stats.totalComplaints}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0">
                                <div className="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <span className="text-white text-sm font-bold">P</span>
                                </div>
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">
                                        Pending
                                    </dt>
                                    <dd className="text-lg font-medium text-gray-900">
                                        {stats.pendingComplaints}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0">
                                <div className="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                                    <span className="text-white text-sm font-bold">I</span>
                                </div>
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">
                                        Investigating
                                    </dt>
                                    <dd className="text-lg font-medium text-gray-900">
                                        {stats.investigatingComplaints}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="bg-white overflow-hidden shadow rounded-lg">
                    <div className="p-5">
                        <div className="flex items-center">
                            <div className="flex-shrink-0">
                                <div className="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <span className="text-white text-sm font-bold">R</span>
                                </div>
                            </div>
                            <div className="ml-5 w-0 flex-1">
                                <dl>
                                    <dt className="text-sm font-medium text-gray-500 truncate">
                                        Resolved
                                    </dt>
                                    <dd className="text-lg font-medium text-gray-900">
                                        {stats.resolvedComplaints}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* Quick Actions */}
            <div className="bg-white shadow rounded-lg">
                <div className="px-4 py-5 sm:p-6">
                    <h3 className="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Quick Actions
                    </h3>
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <button className="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Submit New Complaint
                        </button>
                        <button className="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            View All Complaints
                        </button>
                        {isAdmin && (
                            <button className="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Manage Officials
                            </button>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Dashboard;
