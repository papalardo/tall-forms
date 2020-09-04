// import ImageResize from 'quill-image-resize'
// import QuillImageDropAndPaste from 'quill-image-drop-and-paste'

export default {
    computed: {
        uploadImageServerEnabled() {
            return Boolean(this.uploadImageEndpoint)
        },
        toolbarOptions() {
            return [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],

                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean'] 
            ]
        }
    },
    methods: {
        addModuleToolbar() {
            this.quillModules.toolbar = this.toolbarOptions

            /**
             * Trick to get this.editor before Quill created
             */
            this.$nextTick(() => {
                if(this.uploadImageServerEnabled) {
                    // Add custom upload to server
                    this.editor.getModule('toolbar').addHandler('image', () => {
                        // manipulate the DOM to do a click on hidden input
                        this.$refs.imageInput.click()
                    });
                }
            })
        },
        registerModules(Quill) {
            this.addModuleToolbar()

            /**
             * 
            this.addModule(Quill, 'imageResize', ImageResize, {
                modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
            })

            this.addModule(Quill, 'imageDropAndPaste', QuillImageDropAndPaste, {
                handler: (imageDataUrl, type, imageData) => {
                    this.imageHandler(
                        // Create file
                        imageData.toFile(
                            // On this handler is not available file name, then is generated random method
                            `${Math.random().toString(36).substr(2, 9)}.png`
                        )
                    )
                }
            })
             */

            return Quill
        },
        addModule(Quill, name, bundle, config = {}) {
            Quill.register(`modules/${name}`, bundle);
        
            this.quillModules[name] = config;
        },
    }
}