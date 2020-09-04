module.exports = {
    purge: {
        content: [
            './resources/views/**/*.blade.php',
            './resources/css/**/*.css',
        ],
        options: {
            whitelistPatterns: [/^col-span-/]
        }
    },
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
