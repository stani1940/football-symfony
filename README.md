# Football Prediction App - Symfony + React

A football prediction application built with Symfony backend and React frontend.

## Project Status

🚧 **In Development** - Currently implementing backend entities and API

## Features (Planned)

- **User Authentication** - JWT-based authentication with registration and login
- **Team Management** - View teams and their match history
- **Game Tracking** - Track upcoming and finished football matches
- **Predictions** - Users can predict match scores
- **Points System** - Earn points based on prediction accuracy:
  - 3 points for exact score
  - 1 point for correct outcome (win/draw/loss)
  - 0 points for incorrect prediction
- **Leaderboard** - View user rankings based on total points

## Tech Stack

### Backend (Symfony 7.2)
- **Doctrine ORM** - Database management
- **Symfony Security** - Authentication and authorization
- **Lexik JWT Authentication** - JWT token handling
- **Nelmio CORS** - CORS support for React frontend
- **Symfony Serializer** - JSON API responses
- **Symfony Validator** - Request validation

### Frontend (React)
- **React 18** - UI library
- **React Router** - Client-side routing
- **Axios** - HTTP client
- **Vite** - Build tool and dev server

## Installation

### Prerequisites
- PHP 8.3+
- Composer
- MySQL/PostgreSQL
- Node.js 18+

### Backend Setup

```bash
# Install dependencies
composer install --ignore-platform-req=ext-sodium

# Configure database in .env
# DATABASE_URL="mysql://user:password@127.0.0.1:3306/football_db"

# Create database
php bin/console doctrine:database:create

# Run migrations (when available)
php bin/console doctrine:migrations:migrate

# Generate JWT keys
php bin/console lexik:jwt:generate-keypair

# Start Symfony server
symfony server:start
```

### Frontend Setup (Coming Soon)

```bash
cd frontend
npm install
npm run dev
```

## Development Progress

- [x] Initialize Symfony project
- [x] Install required bundles (ORM, Security, JWT, CORS, Serializer)
- [ ] Configure database connection
- [ ] Create entities (User, Role, Team, Game, Prediction)
- [ ] Generate migrations
- [ ] Create API controllers
- [ ] Set up JWT authentication
- [ ] Initialize React frontend
- [ ] Build React components
- [ ] Connect frontend to backend API

## License

MIT
