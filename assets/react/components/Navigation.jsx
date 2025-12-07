import React from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';

const Navigation = () => {
    const { isAuthenticated, user, logout } = useAuth();
    const [isMenuOpen, setIsMenuOpen] = React.useState(false);

    const toggleMenu = () => setIsMenuOpen(!isMenuOpen);

    React.useEffect(() => {
        if (isMenuOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'unset';
        }
    }, [isMenuOpen]);

    return (
        <header className="header">
            <div className="container-nav">
                <nav className="navigation">
                    <Link to="/" className="logo">
                        <span className="logo-text">Football Symfony</span>
                    </Link>

                    <div className="hamburger" onClick={toggleMenu}>
                        <span className={isMenuOpen ? "bar active" : "bar"}></span>
                        <span className={isMenuOpen ? "bar active" : "bar"}></span>
                        <span className={isMenuOpen ? "bar active" : "bar"}></span>
                    </div>

                    <ul className={`nav_menu ${isMenuOpen ? "active" : ""}`}>
                        <li className="nav_list">
                            <Link to="/events" className="nav_link" onClick={() => setIsMenuOpen(false)}>Events</Link>
                        </li>
                        <li className="nav_list">
                            <Link to="/scoreboard" className="nav_link" onClick={() => setIsMenuOpen(false)}>Scoreboard</Link>
                        </li>
                        <li className="nav_list">
                            <Link to="/results" className="nav_link" onClick={() => setIsMenuOpen(false)}>Results</Link>
                        </li>
                        <li className="nav_list">
                            <Link to="/rules" className="nav_link" onClick={() => setIsMenuOpen(false)}>Rules</Link>
                        </li>

                        {isAuthenticated ? (
                            <>
                                <li className="nav_list">
                                    <Link to="/dashboard" className="nav_link" onClick={() => setIsMenuOpen(false)}>Profile</Link>
                                </li>
                                <li className="nav_list">
                                    <button onClick={() => { logout(); setIsMenuOpen(false); }} className="nav_link btn-link">SignOut</button>
                                </li>
                            </>
                        ) : (
                            <>
                                <li className="nav_list">
                                    <Link to="/register" className="nav_link" onClick={() => setIsMenuOpen(false)}>SignUp</Link>
                                </li>
                                <li className="nav_list btn-nav">
                                    <Link to="/login" className="btn-outline" onClick={() => setIsMenuOpen(false)}>
                                        <span>SignIn</span>
                                    </Link>
                                </li>
                            </>
                        )}
                    </ul>
                </nav>
            </div>
        </header>
    );
};

export default Navigation;
