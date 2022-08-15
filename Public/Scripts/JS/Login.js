// Application class
class Application extends React.Component {
    // Render method
    render() {
        return [<Header />, <Main />, <Footer />];
    }
}
// Header class
class Header extends Application {
    // Render method
    render() {
        return (
            <header>
                <div>
                    <a href="/">Chat</a>
                </div>
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
                <form method="POST">
                    <div id="usernameOrMailAddress">
                        <div class="label">Username / MailAddress:</div>
                        <div>
                            <input
                                type="text"
                                name="usernameOrMailAddress"
                                placeholder="Username / Mail Address"
                                required
                            />
                        </div>
                    </div>
                    <div id="password">
                        <div class="label">Password:</div>
                        <div>
                            <input
                                type="password"
                                name="password"
                                placeholder="Password"
                                required
                            />
                        </div>
                    </div>
                    <div id="button">
                        <button>Login</button>
                    </div>
                </form>
            </main>
        );
    }
}
// Footer class
class Footer extends Application {
    // Render method
    render() {
        return (
            <footer></footer>
        );
    }
}
// Rendering page
ReactDOM.render(<Application />, document.getElementById("login"));