<template>
<div class="contaienr pb-2">
    <article class="note-article row">
        
        <router-link class="avatar_icon col-2" :to="{ name: 'users', params: { userId: note.author.id}}" v-if="true">
            <img class="img-fluid" src="https://image.flaticon.com/icons/png/512/63/63699.png" />
            
        </router-link>
        
        
        <div class="content col-10">
            <header>
            <router-link class="user_name" :to="{ name: 'user_detail', params: { userId: note.author.id}}">
                {{ note.author.user_name }}
            </router-link>   

            </header>
            <div class="main-content">
                <p>
                    {{ note.text }}
                </p>

                <summary-component :summary="note.summary"/>        
                        
            </div>
            <footer class="nav-note">
            </footer>

        </div>
    </article>
</div>        

</template>
<script>
import SummaryComponent from './SummaryComponent.vue';

export default {
    components: {
        'summary-component': SummaryComponent
    },
    props: {
        note: {
            type: Object,
            required: true
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