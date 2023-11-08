/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: 'class',
    mode: 'jit',
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      './resources/js/**/*.vue',
    ],
    theme: {
      extend: {},
    },
    plugins: [],
    important: '.my-component-scoped'
  }