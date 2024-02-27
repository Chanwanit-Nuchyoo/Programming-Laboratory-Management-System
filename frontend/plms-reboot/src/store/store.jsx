import { atomWithStorage } from 'jotai/utils';
import { atom } from 'jotai';

export const defaultCon = {
  "reserved_words": [],
  "functions": [],
  "methods": [],
  "variables": [],
  "imports": [],
  "classes": [],
}

export const suggested_constraintsstraints = atom(defaultCon);

export const user_defined_constraintsstraints = atom(defaultCon);

export const userAtom = atomWithStorage('user', null);

export const sidebarSelectedAtom = atom(0);

export const serverTimeOffsetAtom = atomWithStorage('serverTimeOffset', null);