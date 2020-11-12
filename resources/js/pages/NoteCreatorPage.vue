<template>
    <v-modal 
        title="作成！！"
        ref="modal"
        @show="clear"
        @ok="okListener"
    >
        <form @submit="submitListener">
            <text-field
                :required="true"
                :autofocus="true"
                type="url"
                v-model="url"
                :error="errors['url']"
            />
        </form>

        
    </v-modal>
</template>
<script>
import TextFieldComponent from '../components/TextFieldComponent.vue';

export default {
    components: {
        'text-field': TextFieldComponent
    },
    data(){
        return {
            url: '',
            text: '',
            tag: {
                name: ''
            },
            tags: [],
            erorrs: []
        };
    },
    methods: {
        tryCreate(){
            this.$store.dispatch('createNote', this)
                .then((res)=>{
                    this.clear();

                    this.$nextTick(() => {
                        this.$bvModal.hide('modal-prevent-closing')
                    })
                })
                .catch((e)=>{

                });
        },
        okListener(e){
            e.preventDefault()
        },
        submitListener(){
            tryCreate();
        },
        addTag(){
            if(this.tag.name){
                this.tags.push(this.tag.name);
            }
        },
        clear(){
            this.url = '';
            this.text = '';
            this.tag = { name: '' };
            this.tags = [];
        }
    }
}
</script>