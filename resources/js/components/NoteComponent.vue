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
            <footer class="nav-note">
                <div class="row no-padding-rl">
                    <tags-component
                        class="col-md-11 col-sm-10" 
                        :tags="note.tags"
                    />
                    <favorite-button 
                        class="col-md-1 col-sm-1 no-padding-rl" 
                        :favorite="note.is_favorited"
                        @favorite="favorite"
                        @unfavorite="unfavorite"
                        v-if="note.is_favorited !== undefined"
                        />

                </div>
                
                
            </footer>

        </div>
    </article>
</div>        

</template>
<script>
import SummaryComponent from './SummaryComponent.vue';
import TagsComponent from './TagsComponent.vue';
import AvatarIcon from '../atoms/AvatarIcon';
import FavoriteButton from '../atoms/FavoriteButton';

export default {
    components: {
        'summary-component': SummaryComponent,
        'tags-component': TagsComponent,
        'avatar-icon': AvatarIcon,
        'favorite-button': FavoriteButton
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
        },
        favorite(){
            this.$emit('favorite', this.note.id);
        },
        unfavorite(){
            this.$emit('unfavorite', this.note.id);

        }
    }
}
</script>
<style scoped>
.content{
    padding-left: 0;
}

.no-padding-rl{
    padding-left: 0;
    padding-right: 0;
}
</style>