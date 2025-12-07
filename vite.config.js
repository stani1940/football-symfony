import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
    port: 5173,
    cors: {
      origin: "*",
      methods: ["GET", "POST", "PUT", "DELETE", "PATCH", "OPTIONS"],
      allowedHeaders: ["X-Requested-With", "content-type", "Authorization"]
    },
    proxy: {
      '/api': {
        target: 'http://football-symfony.test',
        changeOrigin: true,
      }
    }
  },
  build: {
    outDir: 'public/build',
    manifest: true,
    rollupOptions: {
      input: 'assets/react/main.jsx'
    }
  }
})
