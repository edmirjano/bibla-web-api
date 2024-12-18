import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './src/**/*.{html,js,css}',
    ],

    theme: {
        colors: {
            'dark' : '#212529',
            'dark-hover' : '#414952',
            'button-white': '#fcfcfc',
            'light-gray' : '#F3F4F6',
            'table-gray' : '#D1D5DB',
            'error-red' : '#ef4444'
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                '450px': { 'max': '450px' },
            },
        },
    },

    plugins: [forms],

};
