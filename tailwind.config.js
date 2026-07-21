import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/{articles,auth,categories,components,layouts,pagination,profile}/**/*.blade.php',
        './resources/views/partials/footer.blade.php',
        './resources/views/{about,blog,contact,dashboard,home}.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
