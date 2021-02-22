
class Contact extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            username: null,
            mobile: null,
            email: null,
            comments: null,
            error: false,
            errMsg: null
        }
    }

    doSendEmail = () => {
        const { username, mobile, email, comments } = this.state;
        if (username && mobile && email && comments) {
            this.setState({ error: true, errMsg: 'Sending an email' });
        } else {
            this.setState({ error: true, errMsg: 'Fill all the details' });
        }
    }

    render() {
        const { username, mobile, email, comments, error, errMsg } = this.state;
        return (
            <div>
                { error && <div className="alert alert-danger" style={{ borderRadius: 0}}>{ errMsg }</div>}
                <div style={{ marginBottom: 10 }}>
                    <input onChange={(ev) => this.setState({ username: ev.target.value })} type="text" value={username} placeholder="Full name" className="form-control" />
                </div>
                <div style={{ marginBottom: 10 }}>
                    <input onChange={(ev) => this.setState({ mobile: ev.target.value })} type="text" value={mobile} placeholder="Mobile no" className="form-control" />
                </div>
                <div style={{ marginBottom: 10 }}>
                    <input onChange={(ev) => this.setState({ email: ev.target.value })} type="text" value={email} placeholder="Email" className="form-control" />
                </div>
                <div style={{ marginBottom: 10 }}>
                    <textarea onChange={(ev) => this.setState({ comments: ev.target.value })} placeholder="Comments" rows="4" className="form-control">{ comments }</textarea>
                </div>
                <button onClick={ () => this.doSendEmail() } type="button" className="btn btn-sm btn-primary">Send</button>
            </div>
        )
    }
}