export interface InputProps {
    name?: string;
    id?: string;
    label?: string;
    type?: string;
    value?: string;
    class?: string;
    placeholder?: string;
    required?: boolean;
    description?: string;
}

export default function Input(props: InputProps = {type: 'text', required: false, class: ''}) {
    return (
        <div className="form-group">
            <label className="col-form-label" htmlFor={props.id}>
                { props.label || props.name }
                {props.required ? (
                    <abbr>*</abbr>
                ): ''}
            </label>

            <input
                type={props.type}
                name={props.name}
                className={`form-control ${props.class || ''}`}
                id={props.id}
                defaultValue={props.value}
                autoComplete="off"
                placeholder={props.placeholder}
                required={props.required}
            />

            {props.description && (
                <small className="form-text text-muted">{props.description}</small>
            )}
        </div>
    );
}
