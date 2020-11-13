<template>
<div class="contaienr pb-2">
    <article class="note-article row">
        
        <router-link class="avatar_icon col-2" :to="{ name: 'user_detail', params: { userId: note.author.id}}" v-if="true">
            <img 
                class="img-fluid" 
                :src="note.author.avatar_icon ? note.author.avatar_icon : 'ic_avatar.png'" 
                v-on:error="loadAvatarIcon" 
            />
            
        </router-link>
        
        
        <div class="content col-10">
            <header>
            <router-link class="user_name" :to="{ name: 'user_detail', params: { userId: note.author.id}}">
                <h5>
                    {{ note.author.user_name }}
                </h5>
            </router-link>   

            </header>
            <div class="main-content">
                <p>
                    {{ note.text }}
                </p>

                <summary-component :summary="note.summary"/>        
                        
            </div>
            <footer class="nav-note">
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

export default {
    components: {
        'summary-component': SummaryComponent,
        'tags-component': TagsComponent
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