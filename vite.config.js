import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [laravel(["resources/css/app.css", "resources/js/app.js"])],
    server: {
        host: "0.0.0.0", // Allow Vite to listen on all interfaces
        hmr: {
            host: "192.168.0.118", // Replace with your computer's IP
        },
    },
});
