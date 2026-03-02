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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'leboss': {
                    50: '#FFF4ED',
                    100: '#FFE6D5',
                    200: '#FFCAA8',
                    300: '#FFA370',
                    400: '#FF7A36',
                    500: '#E57125',
                    600: '#D55A0E',
                    700: '#B4470A',
                    800: '#94380C',
                    900: '#7A2E0C',
                },
                'navy': {
                    50: '#f0f4f8',
                    100: '#d9e2ec',
                    200: '#bcccdc',
                    300: '#9fb3c8',
                    400: '#829ab1',
                    500: '#627d98',
                    600: '#486581',
                    700: '#334e68',
                    800: '#243b53',
                    900: '#102a43',
                    950: '#0a1929',
                },
            },
        },
    },

    plugins: [forms],
};
