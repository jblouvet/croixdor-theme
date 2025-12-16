import fs from 'fs';
const config = JSON.parse(fs.readFileSync('../../../site.config.json', 'utf-8'));
const themeName = __dirname.split('/').pop();
import tailwindcss from '@tailwindcss/vite'
import { defineConfig } from "vite";

export default defineConfig({
  experimental: {
    renderBuiltUrl(filename) {
      return {
        relative: true
      }
    }
  },
  base: config.environment === 'local'
    ? '/'
    : `/wp-content/themes/${themeName}/assets`,
  publicDir: "src/static",
  build: {
    assetsDir: "",
    emptyOutDir: true,
    manifest: true,
    manifestDir: '.',
    outDir: `assets`,
    rollupOptions: {
      input: "src/js/index.js",
    },
  },
  css: {
    devSourcemap: true,
  },
  plugins: [
    tailwindcss(),
    {
      name: "php",
      handleHotUpdate({ file, server }) {
        if (file.endsWith(".php")) {
          server.ws.send({ type: "full-reload", path: "*" });
        }
      },
    },
  ],
  server: {
    port: 3000,
    cors: true,
    origin: 'http://localhost:3000'
  },
});
