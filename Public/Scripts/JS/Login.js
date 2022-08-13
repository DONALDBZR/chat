// Application class
class Application extends React.Component {
    // Render method
    render() {
        return [<Header />, <Main />];
    }
}
// Header class
class Header extends Application {
    // Render method
    render() {
        return (
            <header>
                <h1>Chat</h1>
            </header>
        );
    }
}
// Main class
class Main extends Application {
    // Render method
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
ReactDOM.render(<Application />, document.getElementById("homepage"));