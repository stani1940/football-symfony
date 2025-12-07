import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useAuth } from '../context/AuthContext';
import Navigation from './Navigation';

const Home = () => {
    const { isAuthenticated, user } = useAuth();
    const [countdown, setCountdown] = useState({
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0
    });

    // Countdown timer - set your target date here
    useEffect(() => {
        const targetDate = new Date('2026-06-11T00:00:00').getTime();

        const interval = setInterval(() => {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                clearInterval(interval);
                return;
            }

            setCountdown({
                days: Math.floor(distance / (1000 * 60 * 60 * 24)),
                hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
                seconds: Math.floor((distance % (1000 * 60)) / 1000)
            });
        }, 1000);

        return () => clearInterval(interval);
    }, []);

    const formatNumber = (num) => String(num).padStart(2, '0');

    return (
        <section id="hero">
            <Navigation />

            <div className="hero-main-container">
                <div className="container-hero">
                    <div className="hero-container">
                        <div className="hero-content">
                            <h1 className="section-heading">
                                Our football dream <br /> start here!
                            </h1>
                            <p className="paragraph">
                                Come for European Cup matches & enjoy!
                            </p>

                            <div className="cup-count-down">
                                <div className="count">
                                    <h3 className="days">{formatNumber(countdown.days)}</h3>
                                    <span className="count-time">days</span>
                                </div>
                                <div className="count">
                                    <h3 className="hours">{formatNumber(countdown.hours)}</h3>
                                    <span className="count-time">hours</span>
                                </div>
                                <div className="count">
                                    <h3 className="minutes">{formatNumber(countdown.minutes)}</h3>
                                    <span className="count-time">minutes</span>
                                </div>
                                <div className="count">
                                    <h3 className="seconds">{formatNumber(countdown.seconds)}</h3>
                                    <span className="count-time">seconds</span>
                                </div>
                            </div>

                            {!isAuthenticated && (
                                <div className="hero-actions">
                                    <Link to="/login" className="btn-secondary">Sign In</Link>
                                </div>
                            )}
                        </div>

                        <div className="hero-image">
                            <div className="hero-img-placeholder">
                                <img
                                    src="/images/mascot.png"
                                    alt="World Cup 2026 Mascots: Maple, Zayu, and Clutch"
                                    className="hero-svg"
                                    style={{ width: '100%', height: 'auto', borderRadius: '20px' }}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Home;
