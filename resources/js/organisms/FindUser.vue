<template>
    <div>
        <div>
            <h3>ユーザーを探す</h3>
            <p>ユーザーが利用しているタグをもとにユーザーを探してみましょう。</p>
        </div>
        <div class="mb-3">
            <search-tag @changed="fetch" />
        </div>
        <div class="card">
            <div class="card-header">
                タグに関連するユーザー
            </div>
            <div class="card-body">
                <div v-if="isLoading" class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div v-else>
                    <user-followee 
                        v-for="u in users" 
                        :key="u.id" :user="u" 
                        :me="user"
                        @follow="follow(u)"
                        @unfollow="unfollow(u)"
                    />
                </div>
            </div>

        </div>

    </div>
</template>
<script>
import SearchTag from './SearchTag';
import UserFollowee from '../components/FolloweeComponent';
import axios from 'axios';
import { mapState, mapActions } from 'vuex';

export default {
    components: {
        SearchTag,
        UserFollowee
    },
    data() {
        return {
            userIds: [],
            isLoading: false,
            loadVersion: 0
        }
    },

    computed: {
        users(){
            let f = this.$store.getters['getByUserIds'];
            let users = f(this.userIds);
            console.log('computed');
            console.log(this.$store.getters['getByUserIds']);
            console.log(users);
            return users;
        },
        ...mapState(['user'])
    },

    methods: {
        fetch(tags) {
            this.loadVersion ++;
            let lv = this.loadVersion;
            this.isLoading = true;
            axios.get('/api/users-relatid-to-tags', {
                params: { tags: tags.map((tag)=> tag.name) }
            }).catch((e)=>{
                console.log(e);
            }).then((res)=>{
                if(lv == this.loadVersion){
                    let users = res.data;
                    this.$store.commit('users', users);
                    this.userIds = users.map((u)=> u.id);
                }
            }).finally(()=>{
                if(lv == this.loadVersion){
                    this.isLoading = false;
                }
            })
        },

        ...mapActions(['follow', 'unfollow']),
    },

    

    created() {
        this.fetch([]);
    }
}
</script>