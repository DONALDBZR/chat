/**
 * The application that is going to be rendered by React.js.
 */
class Application extends React.Component {
    render() {
        return [<Header />, <Main />];
    }
}
/**
 * The header component of the application which has the header tag as parent
 */
class Header extends Application {
    render() {
        return (
            <header>
                <h1>Chat</h1>
            </header>
        );
    }
}
/**
 * The main component of the application which has the main tag as parent
 */
class Main extends Application {
    render() {
        return (
            <main>
                <div>
                    <a href="/Login">Login</a>
                </div>
                <div>
                    <a href="/Register">Register</a>
                </div>
            </main>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.body);