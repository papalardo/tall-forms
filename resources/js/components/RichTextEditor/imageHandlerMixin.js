
export default {
    methods: {
        imageHandler(image) {
            var data = new FormData();
            data.append('image', image);

            let axiosConfig = this.imageHandlerGetAxiosConfig()

            axiosConfig.onUploadProgress = (progressEvent) => {
                this.uploadImageProgress = Math.round((progressEvent.loaded * 100) / progressEvent.total)
            }
        
            axios.post(this.uploadImageEndpoint, data, axiosConfig)
                .then(this.imageHandlerOnSuccess)
                .catch(this.imageHandlerOnError)
                .finally(this.imageHandlerOnDone)
        },
        imageHandlerOnSuccess({ data }) {
            this.imageHandleImageInsertOnEditor(data.file)
                    
            const mediaId = data.mediaId;

            if(this.livewireSetMediaIds && !mediaId) {
                console.warn('[Component: RichText] - {mediaId} not found on resquest')
            } 

            if(mediaId) {
                this.mediaIds.push(mediaId)
                this.$emit('mediaIdsChange', this.mediaIds)
                if(this.livewireSetMediaIds) {
                    this.setLivewireMediaIds()
                }       
            }
        },
        imageHandlerOnError(err) {
            alert('Error: ' + err.response.data.message)
        },
        imageHandlerOnDone() {
            this.uploadImageProgress = 0
        },
        imageHandleImageInsertOnEditor(url) {
            // Get the current cursor position.
            const range = this.editor.getSelection();

            // Insert the image via URL where the cursor is.
            this.editor.insertEmbed(range.index, 'image', 
                // Prevent bug when change website protocol
                url.replace(/^http(s?):/, '')
            );

            // Create new line after image
            this.editor.insertText(range.index + 1, '\n');

            // Move the cursor to new line
            this.editor.setSelection(range.index + 2);
        },
        imageHandlerGetAxiosConfig() {
            const axiosConfig = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            if(this.csrfToken) {
                axiosConfig.headers['X-CSRF-TOKEN'] = this.csrfToken
            }

            return axiosConfig;
        },
    }
}