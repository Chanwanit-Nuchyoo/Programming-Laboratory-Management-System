/* eslint-disable no-unused-vars */
/* eslint-disable react/prop-types */
import React from 'react';
import CodeMirror from '@uiw/react-codemirror';
import { githubDark } from "@uiw/codemirror-theme-github"
import { python } from '@codemirror/lang-python';

const MyCodeEditor = ({ editable = true, highlight, basicSetup: bs, height, ...props }) => {
  return (
    <CodeMirror
      {...props}
      theme={githubDark}
      extensions={[python()]}
      editable={editable}
      readOnly={!editable}
      basicSetup={{
        tabSize: 4,
        lineNumbers: true,
        highlightActiveLineGutter: true,
        highlightSpecialChars: true,
        history: true,
        foldGutter: true,
        drawSelection: true,
        dropCursor: true,
        allowMultipleSelections: true,
        indentOnInput: true,
        syntaxHighlighting: false,
        bracketMatching: true,
        closeBrackets: true,
        autocompletion: true,
        rectangularSelection: true,
        crosshairCursor: true,
        highlightActiveLine: true,
        highlightSelectionMatches: true,
        closeBracketsKeymap: true,
        defaultKeymap: true,
        searchKeymap: true,
        historyKeymap: true,
        foldKeymap: true,
        completionKeymap: true,
        lintKeymap: true,
        ...bs,
      }}
      mode={"python"}
      style={{
        fontSize: "16px",
      }}
    />
  );
};

export default MyCodeEditor;
