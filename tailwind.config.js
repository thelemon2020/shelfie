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
            'raspi': {'raw': '(min-height:400),(min-width:800)'},
        },
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
