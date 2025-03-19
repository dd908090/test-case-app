import { Link, router } from '@inertiajs/react';
import '/var/www/link-app-v2/resources/css/IndexPageStyle.css';

export default function IndexPage({ links }) {
  const deleteLink = (linkId) => {
    // Удаление ссылки с вызовом метода контроллера
    router.delete(route('links.destroy', { link: linkId }));
  };

  const editLink = (linkId) => {
    // Редактирование ссылки с вызовом метода контроллера
    router.get(route('links.edit', { link: linkId }));
  };

  const createLink = () => {
    // Переход к созданию новой ссылки
    router.get(route('links.create'));
  };

  const handleRedirect = (shortLink) => {
    // Переход по короткой ссылке
    router.get(route('links.redirect', { short_link: shortLink }));
  };

  const showLinkDetails = (linkId) => {
    // Переход к просмотру подробной информации о ссылке
    router.get(route('links.show', { link: linkId }));
  };

  return (
    <div className="container">
      <div className="header">
        <h1>Ваши короткие ссылки</h1>
      </div>

      <div className="button-container">
        <Link
          href={route('links.create')}
          className="create-button"
        >
          Создать новую ссылку
        </Link>
      </div>

      <div className="table-container">
        <table className="link-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Оригинальная ссылка</th>
              <th>Короткая ссылка</th>
              <th>Дата истечения</th>
              <th>Действия</th>
            </tr>
          </thead>
          <tbody>
            {links.map(link => (
              <tr key={link.id}>
                <td>{link.id}</td>
                <td>
                  <a href={link.original_url} target="_blank" rel="noopener noreferrer" className="link">
                    {link.original_url}
                  </a>
                </td>
                <td>
                  <Link
                    href={route('links.redirect', { short_link: link.short_url })}
                    className="link-button"
                  >
                    http://{link.short_url}
                  </Link>
                </td>
                <td>{new Date(link.expired_at).toLocaleString()}</td>
                <td>
                  <button
                    className="action-button"
                    onClick={() => showLinkDetails(link.id)}
                  >
                    Подробнее
                  </button>
                  <button
                    className="action-button"
                    onClick={() => editLink(link.id)}
                  >
                    Редактировать
                  </button>
                  <button
                    className="action-button"
                    onClick={() => deleteLink(link.id)}
                  >
                    Удалить
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
