export class TimelineStore{

    constructor(
        { isLoading, notes, currentPage } = { isLoading: false, notes: [], currentPage: 0}
    ){
        this.notes = notes;
        this.isLoading = isLoading;
        this.currentPage = currentPage;
    }
    loadNext(){

    }
}

export class DefaultTimelineStore extends TimelineStore{

    constructor(
        store
    ){
        super(store.timeline);
        this.store = store;
    }

    loadNext(){
        this.store.dispatch('loadNext');
    }   
}