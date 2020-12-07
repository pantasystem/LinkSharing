import Vue from 'vue';
import axios from 'axios';

export default {

    namespaced: false,

    state(){
        return {
            notes: {},

        }
    },

    mutations: {
        setNotes(state, notes){
            console.assert(Array.isArray(notes), "notesは配列である必要があります");
            for(let i = 0; i < notes.length; i ++ ){
                let note = notes[i];
                Vue.set(state.notes, new String(note.id), note);
            }
        },
        setNote(state, note){
            Vue.set(state.notes, new String(note.id), note);
        }
    },

    actions: {
        favorite({commit , state, getters, rootState}, noteId){
            axios.post(
                `/api/users/${userId}`,
                {},
                {
                    headers: { Authorization: `Bearer ${rootState.token }` }
                    
                },
            ).then((res)=>{
                let note = state.notes[String(noteId)];
                console.assert(note, '無効なノート' + noteId);
                note = {
                    ...note
                };
                note.favorite = true;
                commit('setNote', note);
            }).catch((e)=>{
                console.log(e);
            });
        },
        unfavorite({commit, state, rootState}, noteId){
            axios.delete(
                `/api/notes/${noteId}/favorites`,
                {
                    headers: { Authorization: `Bearer ${rootState.token }` }
                }
            ).then((res)=>{
                let note = state.notes[String(noteId)];
                console.assert(note, "無効なノートが指定されています:" + noteId);
                if(note.id == noteId && res.data.note_id == note.id){

                    note = {
                        ...note
                    };
                    /*note = {
                        ...note
                    };*/
                    note.favorite = false;
                    commit('setNote', note);
                    //Vue.set(state.notes, String(note.id), )
                }
            }).catch((e)=>{
                console.log(e);
            });
        }
    },

    getters: {
        getNotesByIds:(state) => (ids)=>{
            console.assert(Array.isArray(ids), "idsは配列である必要があります。");
            return ids.map((id)=> state.notes[new String(id)]);
        },
        getNoteById:(state) => (id)=>{
            return state.notes[new String(id)];
        }
    }
}