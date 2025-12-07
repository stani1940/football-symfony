import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const Register = () => {
    const navigate = useNavigate();
    const { register } = useAuth();
    const [formData, setFormData] = useState({
        name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        avatar: null,
    });
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
        // Clear error for this field
        if (errors[name]) {
            setErrors(prev => ({ ...prev, [name]: '' }));
        }
    };

    const handleFileChange = (e) => {
        setFormData(prev => ({
            ...prev,
            avatar: e.target.files[0]
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});
        setLoading(true);

        // Client-side validation
        const newErrors = {};
        if (!formData.name) newErrors.name = 'Name is required';
        if (!formData.username) newErrors.username = 'Username is required';
        if (!formData.email) newErrors.email = 'Email is required';
        if (!formData.password) newErrors.password = 'Password is required';
        if (formData.password !== formData.password_confirmation) {
            newErrors.password_confirmation = 'Passwords do not match';
        }

        if (Object.keys(newErrors).length > 0) {
            setErrors(newErrors);
            setLoading(false);
            return;
        }

        // Create FormData for file upload
        const data = new FormData();
        data.append('name', formData.name);
        data.append('username', formData.username);
        data.append('email', formData.email);
        data.append('password', formData.password);
        if (formData.avatar) {
            data.append('avatar', formData.avatar);
        }

        const result = await register(data);
        setLoading(false);

        if (result.success) {
            navigate('/dashboard');
        } else {
            if (typeof result.error === 'object') {
                setErrors(result.error);
            } else {
                setErrors({ general: result.error });
            }
        }
    };

    return (
        <div className="page-container">
            <div className="glass-container">
                <h2>Register</h2>
                <form onSubmit={handleSubmit}>
                    {errors.general && (
                        <div className="error-message" style={{ marginBottom: '20px', textAlign: 'center' }}>
                            {errors.general}
                        </div>
                    )}

                    <div className="form-group">
                        <input
                            type="text"
                            name="name"
                            value={formData.name}
                            onChange={handleChange}
                            required
                        />
                        <label>Name</label>
                        {errors.name && <span className="error-message">{errors.name}</span>}
                    </div>

                    <div className="form-group">
                        <input
                            type="text"
                            name="username"
                            value={formData.username}
                            onChange={handleChange}
                            required
                        />
                        <label>Username</label>
                        {errors.username && <span className="error-message">{errors.username}</span>}
                    </div>

                    <div className="form-group">
                        <input
                            type="email"
                            name="email"
                            value={formData.email}
                            onChange={handleChange}
                            required
                        />
                        <label>Email</label>
                        {errors.email && <span className="error-message">{errors.email}</span>}
                    </div>

                    <div className="form-group">
                        <input
                            type="file"
                            name="avatar"
                            onChange={handleFileChange}
                            accept="image/jpeg,image/jpg,image/png"
                        />
                        <label style={{ position: 'static', transform: 'none', fontSize: '0.9em', marginBottom: '5px' }}>
                            Avatar (optional)
                        </label>
                        {errors.avatar && <span className="error-message">{errors.avatar}</span>}
                    </div>

                    <div className="form-group">
                        <input
                            type="password"
                            name="password"
                            value={formData.password}
                            onChange={handleChange}
                            required
                        />
                        <label>Password</label>
                        {errors.password && <span className="error-message">{errors.password}</span>}
                    </div>

                    <div className="form-group">
                        <input
                            type="password"
                            name="password_confirmation"
                            value={formData.password_confirmation}
                            onChange={handleChange}
                            required
                        />
                        <label>Confirm Password</label>
                        {errors.password_confirmation && (
                            <span className="error-message">{errors.password_confirmation}</span>
                        )}
                    </div>

                    <button type="submit" className="btn-primary" disabled={loading}>
                        {loading ? 'Registering...' : 'Register'}
                    </button>

                    <div className="auth-link">
                        <p>
                            Already have an account? <Link to="/login">Login</Link>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default Register;
