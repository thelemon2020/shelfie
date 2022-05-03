const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./vendor/livewire/livewire/src/views/**/*.blade.php"
    ],
    theme: {
        screens: {
            ...defaultTheme.screens,
            'raspi': {'raw': '(max-height:450px)'},
        },
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
