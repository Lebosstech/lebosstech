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
            colors: {
                // LEBOSS TECH Brand Colors
                'leboss': {
                    50: '#FFF4ED',
                    100: '#FFE6D5',
                    200: '#FFCAA8',
                    300: '#FFA370',
                    400: '#FF7A36',
                    500: '#E57125', // Primary Orange
                    600: '#D55A0E',
                    700: '#B4470A',
                    800: '#94380C',
                    900: '#7A2E0C',
                },
                'leboss-dark': {
                    50: '#F6F6F6',
                    100: '#E7E7E7',
                    200: '#D1D1D1',
                    300: '#B0B0B0',
                    400: '#888888',
                    500: '#6D6D6D',
                    600: '#5D5D5D',
                    700: '#4F4F4F',
                    800: '#454545',
                    900: '#2C2C2C', // Primary Dark
                },
            }
        },
    },

    plugins: [forms],
};
