<template>
<div>
    <b-navbar id="navigation" toggleable="md" class="shadow-sm" fixed="top">
        <div class="container">
            <b-navbar-brand to="/">Linkboard</b-navbar-brand>
                
                

            <b-collapse id="navbarSupportedContent" is-nav>
                <b-navbar-nav class="mr-auto">
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-form @submit.prevent.stop="search">
                        <b-form-input placeholder="タグ検索" class="mr-sm-2" v-model="keyword"/>
                        <b-button type="submit" variant="outline-secondary">検索</b-button>

                    </b-nav-form>
                    <b-nav-item to="/login" v-if="!isLoggedIn">ログイン</b-nav-item>
                    <b-nav-item to="/register" v-if="!isLoggedIn">登録</b-nav-item>
                    <b-nav-item to="/notifications" v-if="isLoggedIn">
                        <i class="fas fa-bell pull-left" height="100%"></i><span class="nav-link d-md-none d-inline icon-title">通知</span>

                    </b-nav-item>
                    <b-nav-item-dropdown :text="user.user_name" v-if="user">
                        <b-dropdown-item to="/profile" v-if="user">
                            プロフィール
                        </b-dropdown-item>
                        <b-dropdown-item @click="logout" v-if="token">
                            ログアウト
                        </b-dropdown-item>
                    </b-nav-item-dropdown>

                </b-navbar-nav>
                
                
            </b-collapse>
            <b-button class="ml-auto mr-1" variant="primary" v-b-modal.note-creator>投稿</b-button>
            <b-navbar-toggle target="navbarSupportedContent" />

        </div>
                
    </b-navbar>
    <b-modal id="note-creator" title="投稿" @ok="okListener">
        <note-create-form ref="notecreator" @submit="submit"/>
    </b-modal>
</div>    
</template>

<script>
import { mapState } from 'vuex';
import NoteCreateForm from './NoteCreateForm.vue';
export default {
    components: {
        'note-create-form': NoteCreateForm
    },
    data(){
        return {
            keyword: ''
        }
    },
    computed: {
        ...mapState([
            'user',
            'token'
        ]),
        isLoggedIn(){
            return this.$store.state.user != null;
        }
    },
    methods: {
        logout(){
            this.$store.dispatch("logout");
            this.$router.push("/login");
        },
        okListener(e){
            console.log("作成しようとしています");
            this.tryCreate();
            e.preventDefault();
        },
        tryCreate(){
            this.$refs.notecreator.create()
            
        },
        submit(note){
            console.log(`作成されたnote: ${JSON.stringify(note)}`);
            
            this.$nextTick(() => {
                this.$bvModal.hide('note-creator')
            });
        },
        search(){
            let tagName = this.keyword;
            this.$router.push(
                {
                    name: 'searchByTag',
                    query: {
                        'condition': [tagName]
                    }
                }
            ).catch((e)=>{ console.log(e)});
        }

    }
}
</script>
<style scoped>
.icon-title{
    margin-left: 0.5em
}
#navigation{
    background-color: white;
}
</style>