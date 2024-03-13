/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/tw-elements/dist/js/**/*.js",
        'node_modules/preline/dist/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {},
    },
    plugins: ['preline/plugin'],
}

