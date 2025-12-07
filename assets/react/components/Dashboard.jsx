import React from 'react';
import { useAuth } from '../context/AuthContext';

const Dashboard = () => {
    const { user, logout } = useAuth();

    const handleLogout = () => {
        logout();
    };

    if (!user) {
        return <div className="loading">Loading...</div>;
    }

    return (
        <div className="dashboard">
            <div className="dashboard-header">
                <h1>Welcome to Dashboard</h1>
                <div className="user-info">
                    {user.avatar && (
                        <img
                            src={`/uploads/avatars/${user.avatar}`}
                            alt={user.name}
                            className="avatar"
                        />
                    )}
                    <div className="user-details">
                        <h3>{user.name}</h3>
                        <p>@{user.username}</p>
                        <p>{user.email}</p>
                    </div>
                    <button onClick={handleLogout} className="btn-logout">
                        Logout
                    </button>
                </div>
            </div>

            <div className="glass-container">
                <h2>User Information</h2>
                <div style={{ marginTop: '20px' }}>
                    <p><strong>ID:</strong> {user.id}</p>
                    <p><strong>Name:</strong> {user.name}</p>
                    <p><strong>Username:</strong> {user.username}</p>
                    <p><strong>Email:</strong> {user.email}</p>
                    <p><strong>Role ID:</strong> {user.roleId}</p>
                    <p><strong>Active:</strong> {user.active ? 'Yes' : 'No'}</p>
                    <p><strong>Admin:</strong> {user.admin ? 'Yes' : 'No'}</p>
                    <p><strong>Staff:</strong> {user.staff ? 'Yes' : 'No'}</p>
                </div>
            </div>
        </div>
    );
};

export default Dashboard;
