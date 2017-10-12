function AppModule() {
    function search(q) {
        console.log(q);
    }

    return {
        search: search,
    }
}
