import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react-swc';

export default defineConfig({
  plugins: [
    react(),
  ],
  resolve: {
    alias: {
      '@': '/src',
    },
  },
  server: {
    host: true,
    port: 5173,
    strictPort: true,
    hmr: {
      port: 5173,
    },
  },
  build: {
    minify: true,
    sourcemap: false, // Disable sourcemaps for production
    brotliSize: false, // Disable size reports for brotli compression
  },
  define: {
    'process.env': {},
  },
});
