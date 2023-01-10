const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/teamup-component-library/src/components/*.vue',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        placeholderColor: {
            primary: '#A6A6A6',
            focus: '#3E3E3E',
            disabled: '#A6A6A6',
            danger: '#e3342f',
        },

        extend: {
            colors: {
                primary: '#093957'
            },

            backgroundImage: {
				'home-hero':
				  "linear-gradient(to right, rgba(9, 57, 87, 0.90), rgba(9, 57, 87, 0.90)), url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1172&q=80')",
			},

            fontFamily: {
                sans: ['Raleway', ...defaultTheme.fontFamily.sans],
            },

            fontSize: {
                body: '14px',
                account: '12px',
                'small-subtitle': '18px',
                subtitle: '16px',
                title: '24px',
            },

            borderRadius: {
                DEFAULT: '12px',
            },

            borderWidth: {
                DEFAULT: '1px',
                0: '0',
                2: '2px',
                3: '3px',
                4: '4px',
                6: '6px',
                8: '8px',
            },
            borderRadius: {
                DEFAULT: '4px',
            },
            height: {
                circleheight: '100vh',
                input: '46px',
            },
            width: {
                circlewidth: '100vh',
            },            
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
