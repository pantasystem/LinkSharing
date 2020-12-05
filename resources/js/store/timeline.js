import axios from 'axios';

export default {
    namespaced: true,
    state(){
        return {
            notes: [],
            isLoading: false,
            currentPage: 0
        }
    },
    mutations: {
        pushNotes(state, notes){
            if(Array.isArray(notes)){
                state.notes.push(...notes);
            }else{
                state.notes.push(notes);
            }

        },
        addNotesAtTheFirst(state, notes){
            if(Array.isArray(notes)){
                state.notes.unshift(...notes);

            }else{
                state.notes.unshift(notes);
            }
        },

        nextPage(state, page){
            if(Array.isArray(page.data) && page.data.length){
                state.notes.push(...page.data);
            }
            state.isLoading = false;
            state.currentPage = page.current_page;
        }

    },
    actions: {
        async createNote({ commit }, note){
            let res = await axios.post(
                'api/notes',
                note,
                {
                    headers: { Authorization: `Bearer ${this.state.token}` }

                }
            );

            let createdNote = res.data;
            commit('addNotesAtTheFirst', createdNote);
            return res;
        },

        loadNext({commit, state, rootState}){
            if(state.isLoading){
                return;
            }
            state.isLoading = true;

            console.log("load開始");
            console.log(rootState.token);
            axios.get(
                '/api/notes',
                {
                    headers: { Authorization: `Bearer ${rootState.token}`},
                    params: { page: state.currentPage + 1 }
                }
            ).then((res)=>{                
                commit('nextPage', res.data);
            }).catch((e)=>{
                console.log(e);
                commit('nextPage', null);
            });


        },

        initTimeline(context){
            console.log("initTimeline開始しました");
            context.state.notes = [];
            context.state.isLoading = false;
            context.state.currentPage = 0;

            context.dispatch('loadNext');
        },

    }
};