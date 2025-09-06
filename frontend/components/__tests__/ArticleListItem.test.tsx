import { render, screen } from "@testing-library/react";
import ArticleListItem from "../ArticleListItem";

describe("ArticleListItem", () => {
  it("renders article title", () => {
    render(<ArticleListItem article={{ id: "1", title: "My Article" }} />);
    expect(screen.getByText("My Article")).toBeInTheDocument();
  });
});
