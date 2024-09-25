/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    'node_modules/preline/dist/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        Alumni: ["Alumni Sans", "sans-serif"],
    },
    colors: {
      'blueV3R': '#0B2341',
    },
    },
  },
  plugins: [
    require('preline/plugin'),
  ],
}