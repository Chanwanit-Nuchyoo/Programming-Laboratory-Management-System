import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react-swc';
import viteCompression from 'vite-plugin-compression';

export default defineConfig({
  plugins: [
    react(),
    viteCompression({ algorithm: 'gzip' }) // Enable gzip compression
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
    outDir: 'dist', // Specify the output directory
    assetsDir: 'assets', // Specify the directory to nest assets under
    sourcemap: false, // Disable sourcemaps for production
    brotliSize: false, // Disable size reports for brotli compression
  },
  define: {
    'process.env': {},
  },
});
