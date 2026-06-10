// js/reactdemo.js

const { useState } = React;
const { render } = ReactDOM;

// Header Component
const Header = () => (
  <header className="header">
    <h1>Nickolas Patino</h1>
    <h2>Jr Web Developer</h2>
  </header>
);

// Projects Component
const Projects = () => {
  const [projects] = useState([
    { id: 1, title: 'React Todo App', description: 'A simple todo list built with React.js' },
    { id: 2, title: 'PHP Blog Site', description: 'A blog site developed using PHP and MySQL' },
    { id: 3, title: 'Responsive Portfolio', description: 'A personal portfolio page using HTML, CSS, and JavaScript' },
  ]);

  return (
    <section className="projects">
      <h3>Projects</h3>
      <ul>
        {projects.map((project) => (
          <li key={project.id}>
            <h4>{project.title}</h4>
            <p>{project.description}</p>
          </li>
        ))}
      </ul>
    </section>
  );
};

// ContactForm Component
const ContactForm = () => {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log('Form submitted:', { name, email, message });
    alert('Message sent successfully!');
  };

  return (
    <form className="contact-form" onSubmit={handleSubmit}>
      <h3>Contact Me</h3>
      <input
        type="text"
        value={name}
        onChange={(e) => setName(e.target.value)}
        placeholder="Your Name"
        required
      />
      <input
        type="email"
        value={email}
        onChange={(e) => setEmail(e.target.value)}
        placeholder="Your Email"
        required
      />
      <textarea
        value={message}
        onChange={(e) => setMessage(e.target.value)}
        placeholder="Your Message"
        required
      />
      <button type="submit">Send</button>
    </form>
  );
};

// Main App Component
const App = () => (
  <div className="app-container">
    <Header />
    <Projects />
    <ContactForm />
  </div>
);

// Render App Component to the DOM
render(<App />, document.getElementById('root'));
