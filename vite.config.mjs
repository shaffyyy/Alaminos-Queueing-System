import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [laravel(["resources/css/app.css", "resources/js/app.js"])],
    server: {
        host: "0.0.0.0",
        hmr: {
            host: "192.168.254.254", // Replace with your machine's local IP
            protocol: "ws",
        },
    },
});
