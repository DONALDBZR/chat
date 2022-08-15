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
    // Constructor method
    constructor(props) {
        super(props);
        this.state = {
            // Input
            name: "",
            password: "",
            // Output
            success: "",
            message: "",
            url: "",
        };
    }
    // Change handler method
    handleChange(event) {
        // Local variables
        const target = event.target;
        const value = target.value;
        const name = target.name;
        // Setting the value of the targeted name
        this.setState({
            [name]: value,
        });
    }
    // Submit handler method
    handleSubmit(event) {
        // Local variables
        const delay = 938;
        // Preventing default submission
        event.preventDefault();
        // Generating a POST request
        fetch("/Controllers/Login.php", {
            method: "POST",
            body: JSON.stringify({
                name: this.state.name,
                password: this.state.password,
            }),
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((response) => response.json())
            .then((data) => this.setState({
                success: data.success,
                message: data.message,
                url: data.url,
            }))
            .then(() => this.redirector(delay));
    }
    // Redirector method
    redirector(delay) {
        setTimeout(() => {
            window.location.href = this.state.url;
        }, delay);
    }
    // Render method
    render() {
        return (
            <main>
                <form method="POST" onSubmit={this.handleSubmit.bind(this)}>
                    <div id="usernameOrMailAddress">
                        <div class="label">Username / MailAddress:</div>
                        <div>
                            <input
                                type="text"
                                name="name"
                                placeholder="Username / Mail Address"
                                value={this.state.name}
                                onChange={this.handleChange.bind(this)}
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
                                value={this.state.password}
                                onChange={this.handleChange.bind(this)}
                                required
                            />
                        </div>
                    </div>
                    <div id="button">
                        <button>Login</button>
                    </div>
                    <div id="serverRendering">
                        <h1 id={this.state.success}>{this.state.message}</h1>
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