import React, {useEffect, useState} from 'react';
import {BrowserRouter, Routes, Route, Link, useParams} from 'react-router-dom';
import {AppRoute} from '../../const';
import PropTypes from 'prop-types';
import Main from '../pages/main/main';
import SignIn from '../pages/signin/signin';
import MyList from '../pages/mylist/mylist';
import Film from '../pages/film/film';
import Review from '../ui/review/review';
import Player from '../pages/player/player';
import filmProp from '../ui/card/card.prop';
import reviewProp from '../ui/review/review.prop';

function App() {
  const [films, setFilms] = useState([]);
  const [genres, setGenres] = useState([]);
  const [reviews, setReviews] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    Promise.all([
      fetch('http://localhost:8000/api/films').then(res => {
        if (!res.ok) throw new Error('Failed to fetch films');
        return res.json();
      }),
      fetch('http://localhost:8000/api/genres').then(res => {
        if (!res.ok) throw new Error('Failed to fetch genres');
        return res.json();
      }),
      fetch('http://localhost:8000/api/comments').then(res => {
        if (!res.ok) throw new Error('Failed to fetch reviews');
        return res.json();
      }),
    ])
      .then(([filmsData, genresData, reviewsData]) => {
        setFilms(filmsData.data);
        setGenres(genresData.data);
        setReviews(reviewsData.data);
      })
      .catch(err => setError(err.message))
      .finally(() => setIsLoading(false));
  }, []);

  if (isLoading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Main films={films} genres={genres} />} />
        <Route path="/login" element={<SignIn />} />
        <Route path="/mylist" element={<MyList films={films} />} />
        <Route path={`${AppRoute.FILM}/:id`} element={<FilmWrapper films={films} reviews={reviews} />} />
        <Route path={`${AppRoute.FILM}/:id/review`} element={<ReviewWrapper films={films} />} />
        <Route path={`${AppRoute.PLAYER}/:id`} element={<PlayerWrapper films={films} />} />
        <Route path="*" element={<NotFound />} />
      </Routes>
    </BrowserRouter>
  );
}

function FilmWrapper({ films, reviews }) {
  const { id } = useParams();
  const film = films.find((f) => f.id === Number(id));

  if (!film) return <NotFound />;
  return <Film film={film} films={films} reviews={reviews} />;
}

function ReviewWrapper({ films }) {
  const { id } = useParams();
  const film = films.find((f) => f.id === Number(id));
  if (!film) return <NotFound />;
  return <Review film={film} />;
}

function PlayerWrapper({ films }) {
  const { id } = useParams();
  const film = films.find((f) => f.id === Number(id));
  if (!film) return <NotFound />;
  return <Player film={film} />;
}

function NotFound() {
  return (
    <>
      <h1>
        404.
        <br />
        <small>Page not found</small>
      </h1>
      <Link to="/">Go to main page</Link>
    </>
  );
}

App.propTypes = {
  films: PropTypes.arrayOf(filmProp).isRequired,
  reviews: PropTypes.arrayOf(reviewProp).isRequired,
};

export default App;
