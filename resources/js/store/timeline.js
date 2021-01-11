import axios from 'axios';

export default {
    namespaced: true,
    state(){
        return {
            noteIds: [],
            isLoading: false,
            currentPage: 0
        }
    },
    mutations: {
        pushNotes(state, notes){
            if(Array.isArray(notes)){
                state.noteIds.push(...notes.map((note)=>note.id));
            }else{
                state.noteIds.push(notes.id);
            }

        },
        addNotesAtTheFirst(state, notes){
            if(Array.isArray(notes)){
                state.noteIds.unshift(...notes.map((note)=>note.id));

            }else{
                state.noteIds.unshift(notes.id);
            }
        },

        nextPage(state, page){
            if(Array.isArray(page.data) && page.data.length){
                state.noteIds.push(...page.data.map((note)=>note.id));
            }
            state.isLoading = false;
            if (page.data != null && page.data.length) {
                state.currentPage = page.current_page;
            }
        }

    },
    actions: {
        async createNote({ commit, }, note){
            let res = await axios.post(
                'api/notes',
                note,
                
            );

            let createdNote = res.data;
            commit('addNotesAtTheFirst', createdNote);
            commit('setNote', createdNote, { root: true});
            return res;
        },

        loadNext({commit, state }){
            if(state.isLoading){
                return;
            }
            state.isLoading = true;

            console.log("load開始");
            axios.get(
                '/api/notes',
                {
                    params: { page: state.currentPage + 1 }
                }
            ).then((res)=>{        
                    
                commit('nextPage', res.data);
                commit('setNotes', res.data.data, {root: true});
            }).catch((e)=>{
                console.log(e);
                commit('nextPage', null);
            });


        },

        initTimeline(context){
            console.log("initTimeline開始しました");
            context.state.noteIds = [];
            context.state.isLoading = false;
            context.state.currentPage = 0;

            context.dispatch('loadNext');
        },

        onTimelineUpdated({ commit, state }, noteId) {
            console.log(noteId);
            axios.get(
                `/api/notes/${noteId}`
            ).then((res) => {
                let createdNote = res.data;
                commit('addNotesAtTheFirst', createdNote);
                commit('setNote', createdNote, { root: true });
            }).catch((e) => {
                console.log(e); 
            });
        }

    },
    getters: {
        notes(state, getters, rootState, rootGetters){
            
            let notes =  rootGetters.getNotesByIds(state.noteIds);
            console.log('timeline#notes');
            console.log(notes);
            return notes;
        }
    }
};