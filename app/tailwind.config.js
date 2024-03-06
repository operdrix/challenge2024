/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./assets/**/*.js",
        "./templates/**/*.html.twig",
        "./node_modules/flowbite/**/*.js" // set up the path to the flowbite package
    ],
    safelist: [
        'w-64',
        'w-1/2',
        'rounded-l-lg',
        'rounded-r-lg',
        'bg-gray-200',
        'grid-cols-4',
        'grid-cols-7',
        'h-6',
        'leading-6',
        'h-9',
        'leading-9',
        'shadow-lg',
        'bg-opacity-50',
        'dark:bg-opacity-80'
    ],
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                primary: { "50": "#13B6F680", "100": "#09ACEC", "200": "#089DD9", "300": "#078FC5", "400": "#0681B1", "500": "#05668D", "600": "#05648A", "700": "#045676", "800": "#044862", "900": "#03394F" },
                secondary: { "50": "#9BC969AA", "100": "#91C45A", "200": "#87BE4B", "300": "#7CB441", "400": "#72A53B", "500": "#679436", "600": "#5D8731", "700": "#53782B", "800": "#496926", "900": "#3E5A20" },
            },
            fontFamily: {
                'sans': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
                'body': ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'],
                'mono': ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Monaco', 'Consolas', 'Liberation Mono', 'Courier New', 'monospace']
            },
            transitionProperty: {
                'width': 'width'
            },
            textDecoration: ['active'],
            minWidth: {
                'kanban': '28rem'
            },
        },
    },

    plugins: [
        require('flowbite/plugin') // add the flowbite plugin
    ],
}
