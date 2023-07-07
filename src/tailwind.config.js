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
              logo: [ "Arial Unicode MS", "sans-serif"],
              title: [ "Toppan Bunkyu Midashi Gothic", "sans-serif"],
              base: [ "Hiragino Sans", "sans-serif"],
              accent: [ "Noto Sans JP", "sans-serif"],
            },
            colors: {
              // 'カラー名': 'カラーコード'
              'main': '#0F9565',
              'vivid': '#EB545D',
              'white': '#FAFAFA',
              'white-90': 'rgba(255, 255, 255, 0.9)',
              'black': '#212121',
              'dark-gray': '#666666',
              'gray': '#CCCCCC',
              'bg': '#E9E9E9',
            },
        },
    },

    plugins: [forms],
};
