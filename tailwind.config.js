import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                'DEFAULT': '0 0 5px 0 rgba(0, 0, 0, 0.08)',
            },
            colors: {
                'gray': {
                    'custom': 'rgba(0, 0, 0, 0.4)',
                },
                'gray-light': '#f5f6f9',
            },
        },
    },

    plugins: [forms],
};
