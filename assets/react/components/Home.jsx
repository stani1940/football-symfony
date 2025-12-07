import React from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const Home = () => {
    const { isAuthenticated, user } = useAuth();

    return (
        <div className="page-container">
            <div className="glass-container">
                <h2>Football Symfony</h2>
                <p style={{ textAlign: 'center', marginBottom: '30px', fontSize: '1.1em' }}>
                    Welcome to the Football Management System
                </p>

                {isAuthenticated ? (
                    <div style={{ textAlign: 'center' }}>
                        <p style={{ marginBottom: '20px' }}>
                            Hello, <strong>{user?.name}</strong>!
                        </p>
                        <Link to="/dashboard">
                            <button className="btn-primary">Go to Dashboard</button>
                        </Link>
                    </div>
                ) : (
                    <div style={{ display: 'flex', gap: '15px', flexDirection: 'column' }}>
                        <Link to="/login">
                            <button className="btn-primary">Login</button>
                        </Link>
                        <Link to="/register">
                            <button className="btn-primary" style={{ background: 'transparent', border: '2px solid #fff', color: '#fff' }}>
                                Register
                            </button>
                        </Link>
                    </div>
                )}
            </div>
        </div>
    );
};

export default Home;
