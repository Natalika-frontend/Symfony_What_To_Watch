import React, { useEffect, useState } from 'react';
import FilmList from '../../ui/film-list/film-list';
import filmProp from '../../ui/card/card.prop';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';
import { AppRoute } from '../../../const';

function Main({genres}) {
  const [films, setFilms] = useState([]);
  const [activeGenre, setActiveGenre] = useState('All genres');
  const [orderBy, setOrderBy] = useState('released');
  const [orderTo, setOrderTo] = useState('desc');
  const [promoFilm, setPromoFilm] = useState(null);

  const [page, setPage] = useState(1);
  const [limit] = useState(8);
  const [total, setTotal] = useState(0);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchPromo();
  }, []);

  useEffect(() => {
    setPage(1);
    fetchFilms(1, true);
  }, [activeGenre, orderBy, orderTo]);

  const fetchPromo = async () => {
    try {
      const res = await fetch('http://localhost:8000/api/promo');
      if (!res.ok) throw new Error('Failed to fetch promo film');
      const data = await res.json();
      setPromoFilm(data.data);
    } catch (err) {
      console.error(err);
    }
  };

  const fetchFilms = async (pageToLoad = page, replace = false) => {
    try {
      setLoading(true);

      const params = new URLSearchParams({
        page: pageToLoad,
        limit,
        'genres': activeGenre === 'All genres' ? [] : [activeGenre],
        orderBy,
        orderDirection: orderTo,
      });

      const res = await fetch(`http://localhost:8000/api/films?${params}`);
      if (!res.ok) throw new Error('Failed to fetch films');
      const data = await res.json();
      setTotal(data.total);
      setPage(data.page);

      if (replace) {
        setFilms(data.data);
      } else {
        setFilms(prev => [...prev, ...data.data]);
      }
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const handleShowMore = () => {
    if (films.length < total) {
      fetchFilms(page + 1);
    }
  };

  if (!films.length && loading) {
    return <div>Loading films...</div>;
  }

  return (
    <React.Fragment>
      <div className="visually-hidden">
        {/* SVG-спрайты остаются без изменений */}
      </div>

      <section className="film-card">
        <div className="film-card__bg">
          <img src={promoFilm?.backgroundImage} alt={promoFilm?.name}  />
        </div>

        <h1 className="visually-hidden">WTW</h1>

        <header className="page-header film-card__head">
          <div className="logo">
            <a href="#" className="logo__link">
              <span className="logo__letter logo__letter--1">W</span>
              <span className="logo__letter logo__letter--2">T</span>
              <span className="logo__letter logo__letter--3">W</span>
            </a>
          </div>

          <ul className="user-block">
            <li className="user-block__item">
              <div className="user-block__avatar">
                <Link to={AppRoute.MY_LIST}>
                  <img src="img/avatar.jpg" alt="User avatar" width="63" height="63" />
                </Link>
              </div>
            </li>
            <li className="user-block__item">
              <a href="#" className="user-block__link">Sign out</a>
            </li>
          </ul>
        </header>

        <div className="film-card__wrap">
          <div className="film-card__info">
            <div className="film-card__poster">
              <img src={promoFilm?.posterImage} alt={`${promoFilm?.name} poster`} width="218" height="327" />
            </div>

            <div className="film-card__desc">
              <h2 className="film-card__title">{promoFilm?.name}</h2>
              <p className="film-card__meta">
                <span className="film-card__genre">{promoFilm?.genres}</span>
                <span className="film-card__year">{promoFilm?.year}</span>
              </p>

              <div className="film-card__buttons">
                <button className="btn btn--play film-card__button" type="button">
                  <svg viewBox="0 0 19 19" width="19" height="19">
                    <use xlinkHref="#play-s"></use>
                  </svg>
                  <span>Play</span>
                </button>
                <button className="btn btn--list film-card__button" type="button">
                  <svg viewBox="0 0 19 20" width="19" height="20">
                    <use xlinkHref="#add"></use>
                  </svg>
                  <span>My list</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div className="page-content">
        <section className="catalog">
          <h2 className="catalog__title visually-hidden">Catalog</h2>

          <ul className="catalog__genres-list">
            <li className={`catalog__genres-item ${
              activeGenre === 'All genres' ? 'catalog__genres-item--active' : ''
            }`}
            >
              <a
                href="#"
                className="catalog__genres-link"
                onClick={(e) => {
                  e.preventDefault();
                  setActiveGenre('All genres');
                }}
              >
                All genres
              </a>
            </li>
            {genres.map((genre) => (
              <li
                key={genre.id}
                className={`catalog__genres-item ${
                  activeGenre === genre.name ? 'catalog__genres-item--active' : ''
                }`}
              >
                <a
                  href="#"
                  className="catalog__genres-link"
                  onClick={(e) => {
                    e.preventDefault();
                    setActiveGenre(genre.name);
                  }}
                >
                  {genre.name}
                </a>
              </li>
            ))}
          </ul>

          <div className="catalog__films-list">
            <FilmList films={films} />
          </div>

          {films.length < total && (
            <div className="catalog__more">
              <button
                className="catalog__button"
                type="button"
                disabled={loading}
                onClick={handleShowMore}
              >
                {loading ? 'Loading...' : 'Show more'}
              </button>
            </div>
          )}
        </section>

        <footer className="page-footer">
          <div className="logo">
            <a href="#" className="logo__link logo__link--light">
              <span className="logo__letter logo__letter--1">W</span>
              <span className="logo__letter logo__letter--2">T</span>
              <span className="logo__letter logo__letter--3">W</span>
            </a>
          </div>
          <div className="copyright">
            <p>© 2019 What to watch Ltd.</p>
          </div>
        </footer>
      </div>
    </React.Fragment>
  );
}

Main.propTypes = {
  genres: PropTypes.arrayOf(
    PropTypes.shape({
      id: PropTypes.number.isRequired,
      name: PropTypes.string.isRequired,
    })
  ).isRequired,
};

export default Main;
