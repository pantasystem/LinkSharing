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
            console.log('setNotes');
            console.log(state.notes);
        },
        setNote(state, note){
            console.log('setNote');
            console.log(note);
            Vue.set(state.notes, new String(note.id), note);
            console.log(state.notes);
        }
    },

    actions: {
        favorite({commit , state }, noteId){
            axios.post(
                `/api/notes/${noteId}/favorites`,
            ).then((res)=>{
                let note = state.notes[String(noteId)];
                console.assert(note, '無効なノート' + noteId);
                note = {
                    ...note
                };
                note.is_favorited = true;
                commit('setNote', note);
            }).catch((e)=>{
                console.log(e);
            });
        },
        unfavorite({commit, state }, noteId){
            axios.delete(
                `/api/notes/${noteId}/favorites`,
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
                    note.is_favorited = false;
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
            console.log(state.notes.length);
            console.log(state.notes);
            let notes = ids.map((id)=> state.notes[new String(id)])
                .filter((note)=>note);
            console.log(typeof(notes));
            console.assert(Array.isArray(notes), "配列ではない値が返ってきます");
            return notes;
        },
        getNoteById:(state) => (id)=>{
            return state.notes[new String(id)];
        }
    }
}