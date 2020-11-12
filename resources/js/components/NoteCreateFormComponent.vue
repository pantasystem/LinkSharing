<template>
    <form @submit="submitListener">
        <b-form-input
         v-model="url"
         placeholder="共有URL"
         class="mb-2"
        />
        <b-form-textarea

            :required="true"
            placeholder="本文"
            v-model="text"
        />

        <div class="row mt-2 contaienr ml-3 mr-3">
            <b-form-checkbox
                v-for="tag in tags" :key="tag.id" @change="deleteTag(tag.id)"
                class="m-1"
            >
                {{tag.name}}
            </b-form-checkbox>
                
        </div>
        <div class="row mt-2 container">
            
            
            <b-form-input
                class="col-7 mr-1"
                placeholder="タグ名"
                v-model="tag"
            />
            <b-button variant="primary" class="col-3" @click="addTag">タグを追加</b-button>
        </div>
        
    </form>
</template>

<script>
export default {
    data(){
        return {
            url: '',
            text: '',
            tag: '',
            tags: []
        }
    },
    methods: {
        addTag(){
            let nextId = this.tags.length;
            let newTag = {
                id: nextId,
                name: this.tag
            };
            this.tags.push(newTag);
            this.tag = '';
        },
        deleteTag(key){
            console.log(`${key}番目のタグを削除しようとしています`);
            this.tags = this.tags.filter((tag)=>
                tag.id != key
            );
        },
        submitListener(){
            this.$emit('submit');
        }
    }
}
</script>