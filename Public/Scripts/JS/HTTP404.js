// Application class
class Application extends React.Component {
    // Render method
    render() {
        return <Header />;
    }
}
// Header class
class Header extends Application {
    // Render method
    render() {
        return (
            <header>
                <h1 id="code">404</h1>
                <h1>not found</h1>
            </header>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.getElementById("http404"));