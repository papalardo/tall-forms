module.exports = {
  purge: [
    './resources/views/**/*.blade.php',
    './resources/css/**/*.css',
  ],
  theme: {
    customForms: theme => ({
      error: {
        'input, textarea, multiselect, checkbox, radio, select': {
          borderColor: theme('colors.red.600'),
        },
      }
    }),
    extend: {}
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms')
  ]
}
