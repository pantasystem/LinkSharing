<template>
<div class="contaienr pb-2">
    <article class="note-article row">
        
        <router-link class="col-2" :to="{ name: 'user_notes', params: { userId: note.author.id}}" v-if="true">
            <avatar-icon
                :user="note.author"
            />
            
        </router-link>
        
        
        <div class="content col-10">
            <header>
            <router-link class="user_name" :to="{ name: 'user_notes', params: { userId: note.author.id}}">
                <h4>
                    {{ note.author.user_name }}
                </h4>
            </router-link>   

            </header>
            <div class="main-content">
                <p>
                    {{ note.text }}
                </p>

                <summary-component :summary="note.summary"/>        
                        
            </div>
            <footer class="nav-note col-12">
                <tags-component 
                    :tags="note.tags"
                />
            </footer>

        </div>
    </article>
</div>        

</template>
<script>
import SummaryComponent from './SummaryComponent.vue';
import TagsComponent from './TagsComponent.vue';
import AvatarIcon from '../atoms/AvatarIcon';

export default {
    components: {
        'summary-component': SummaryComponent,
        'tags-component': TagsComponent,
        'avatar-icon': AvatarIcon
    },
    props: {
        note: {
            type: Object,
            required: true
        }
    },
    methods: {
        loadAvatarIcon(e){
            e.target.src = "ic_avatar.png";
        }
    }
}
</script>
<style scoped>

/*
.note-article{
    display: flex;
}
*/
/*
.avatar_icon{
    width: 58px;
    height: 58px;
    min-width: 58px;
    min-height: 58px;
    margin-right: 8px;
    margin-bottom: 16px;
    background: gray;
}*/
/*
.content{
    flex: 1;
}
*/

</style>