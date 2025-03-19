import { useState } from 'react';
import { router } from '@inertiajs/react';
import '/var/www/link-app-v2/resources/css/CreatePageStyle.css';

export default function CreatePage() {
  const [originalUrl, setOriginalUrl] = useState('');
  const [customUrl, setCustomUrl] = useState('');
  const [expiredAt, setExpiredAt] = useState('');
  const [error, setError] = useState(null);

  const handleSubmit = (e) => {
    e.preventDefault();
    setError(null);

    const data = {
      original_url: originalUrl || '',
      custom_url: customUrl || null,
      expired_at: expiredAt || null,
    };

    router.post(route('links.store'), data, {
      onError: (errors) => setError(errors),
    });
  };

  return (
    <div className="container">
      <div className="header">
        <h1>Создать новую короткую ссылку</h1>
      </div>

      {error && (
        <div className="error-message">
          Пожалуйста, проверьте введенные данные.
        </div>
      )}

      <form onSubmit={handleSubmit} className="form-container">
        <div className="form-group">
          <label className="form-label">Оригинальная ссылка</label>
          <input
            type="url"
            required
            value={originalUrl}
            onChange={(e) => setOriginalUrl(e.target.value)}
            className="form-input"
            placeholder="https://example.com"
          />
        </div>

        <div className="form-group">
          <label className="form-label">Пользовательский URL (опционально)</label>
          <input
            type="text"
            value={customUrl}
            onChange={(e) => setCustomUrl(e.target.value)}
            className="form-input"
            placeholder="Введите свой URL или оставьте пустым"
          />
        </div>

        <div className="form-group">
          <label className="form-label">Дата истечения (опционально)</label>
          <input
            type="date"
            value={expiredAt}
            onChange={(e) => setExpiredAt(e.target.value)}
            className="form-input"
          />
        </div>

        <button
          type="submit"
          className="submit-button"
        >
          Создать ссылку
        </button>
      </form>
    </div>
  );
}
