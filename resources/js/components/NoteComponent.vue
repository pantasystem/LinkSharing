<template>
    
    <article class="note-article p-2 .container">
        <router-link class="avatar_icon" :to="{ name: 'users', params: { userId: note.author.id}}">
            <img  :src="note.author.avatar_url">
            
        </router-link>
        <div class="content .container">
            <header>
            <router-link class="user_name" :to="{ name: 'users', params: { userId: note.author.id}}">
                {{ note.author.user_name }}
            </router-link>   

            </header>
            <div class="main-content">
                <p class="col-md-12">
                    {{ note.text }}
                </p>
                        
                        
            </div>
            <footer class="nav-note">
            </footer>

        </div>
    </article>
</template>
<script>
export default {
    props: {
        note: {
            type: Object,
            required: true
        }
    }
}
</script>
<style scoped>
.note-article{
    display: flex;
}
.avatar_icon{
    width: 58px;
    height: 58px;
    min-width: 58px;
    min-height: 58px;
    margin-right: 8px;
    margin-bottom: 16px;
    background: gray;
}
.content{
    flex: 1;
}

</style>