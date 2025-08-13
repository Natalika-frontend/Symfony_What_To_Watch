import React from 'react';
import { BrowserRouter, Routes, Route, Link } from 'react-router-dom';
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


function App(props) {
  const {films,reviews, name, genre, year} = props;
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Main films={films} name={name} genre={genre} year={year} />}/>
        <Route path="/login" element={SignIn} />
        <Route path="/mylist" element={<MyList films={films} />}/>
        <Route path={`${AppRoute.FILM}/:id`} element={<FilmWrapper films={films} reviews={reviews} />} />
        <Route path={`${AppRoute.FILM}/:id/review`} element={<ReviewWrapper films={films} />} />
        <Route path={`${AppRoute.PLAYER}/:id`} element={<PlayerWrapper films={films} />} />
        <Route path="*" element={<NotFound />} />
      </Routes>
    </BrowserRouter>
  );
}

function FilmWrapper({ films, reviews }) {
  return <Film film={films[0]} films={films} reviews={reviews} />;
}

function ReviewWrapper({ films }) {
  return <Review film={films[0]} />;
}

function PlayerWrapper({ films }) {
  return <Player film={films[0]} />;
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
  name: PropTypes.string.isRequired,
  genre: PropTypes.string.isRequired,
  year: PropTypes.number.isRequired,
};

export default App;
