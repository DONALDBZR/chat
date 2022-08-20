/**
 * The application that is going to be rendered by React.js.
 */
class Application extends React.Component {
    render() {
        return <Header />;
    }
}
/**
 * The header component of the application which has the header tag as parent
 */
class Header extends Application {
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